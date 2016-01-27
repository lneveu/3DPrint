/* jshint laxcomma:true, laxbreak:true*/
var PythonShell   = require('python-shell')
    , fs          = require('fs')
    , path        = require('path')
    , SCRIPT_PATH = __dirname + '/stl_normalize'
    , STLLoader   = require('../threejs/STLLoader.js')
    , ThreeUtils  = require('../threejs/ThreeUtils.js')
    , THREE       = require('three')
    ;

// max dimensions (mm)
var MAX_DIM =
{
  'length'   : 256
  , 'width'  : 169
  , 'height' : 150
};

// min dimensions (mm)
var MIN_DIM =
{
  'length'   : 1
  , 'width'  : 1
  , 'height' : 1
};

var PRICE_MM3 = 0.001; // 1mm3 = 0.001€

module.exports =
{
    /**
     * Check non-manifold AND dimensions
     */
    checkAll : function(file, opts, cb)
    {
        // check if the file exists
        fs.stat(file, function(err, stats)
        {
            if(err || !stats.isFile())
            {
                cb({ "status" : "file not exist", "code" : -2 });
            }
            else
            {
                var ext = path.extname(file);
                if(ext.toLowerCase() === '.stl')
                {
                    verif_nonmanifold(file, function(result) // verif non-manifold
                    {
                      if(result.code === 0) // object valid
                      {
                        verif_dimensions(file, opts, function(result) // verif and get dimensions
                        {
                          cb(result);
                        });
                      }
                      else // object invalid
                      {
                        cb(result);
                      }
                    });
                }
                /*else if(ext.toLowerCase() === '.obj')
                {
                  // not implemented yet
                }*/
                else
                {
                  cb({ "status" : "invalid format", "code" : -4 });
                }
            }
        });
    }

    /**
     * Check dimensions
     */
    , checkDimensions : function(file, opts, cb)
    {
      // check if the file exists
      fs.stat(file, function(err, stats)
      {
          if(err || !stats.isFile())
          {
            cb({ "status" : "file not exist", "code" : -2 });
          }
          else
          {
            verif_dimensions(file, opts, function(result) // verif and get dimensions
            {
              cb(result);
            });
          }
      });
    }
};

/* private functions */
/**
 * Run "stl_normalize" script
 */
var verif_nonmanifold = function(file, cb)
{
    var options =
    {
        scriptPath : SCRIPT_PATH
        , args: ['-c', file]
    };

    // call python scripts
    PythonShell.run('stl_normalize.py', options, function (err, results)
    {
        // TODO séparer et identifier les différents types d'erreurs
        if (err) // invalid model
        {
            console.log('INVALID - File "' + file + '" contains a non-manifold model');
            cb({"status" : "invalid model", "code" : -3 });
        }
        else // valid model
        {
            console.log('VALID - File "' + file + '"');
            cb({"status" : "valid model", "code" : 0 });
        }
    });
};

/**
 * Check and return dimensions (rescale model if needed)
 */
var verif_dimensions = function(file, opts, cb)
{
  var ext      = path.extname(file)
    , geometry = null
    , price    = null
    ;

  if(ext.toLowerCase() === '.stl')
  {
    // parse STL file
    var buf = fs.readFileSync(file);
    geometry = STLLoader.parse(buf);

    if(geometry.type === "BufferGeometry") // we need to transform BufferGeometry to Geometry
    {
      var mesh = new THREE.Mesh(geometry);
      var bbox = new THREE.Box3().setFromObject(mesh);
      geometry.boundingBox = bbox;
      geometry = new THREE.Geometry().fromBufferGeometry(geometry);
    }

    var dim = applyScale(getDimensions(geometry), opts);
    var maxminscale = getMinMaxScale(dim);

    if(dim.length > MAX_DIM.length || dim.width > MAX_DIM.width || dim.height > MAX_DIM.height) // model is too big
    {
      opts.scale = maxminscale.max;
      dim = applyScale(dim, opts);
      price = calculatePrice(dim.volume);
      cb({ "status" : "valid model after rescale (too big)", "code" : 2, "dimensions" : dim, "price" : price, "maxscale" : maxminscale.max, "minscale" : maxminscale.min, "opts" : opts});
    }
    else if(dim.length < MIN_DIM.length || dim.width < MIN_DIM.width || dim.height < MIN_DIM.height) // model is too small
    {
      opts.scale = maxminscale.min;
      dim = applyScale(dim, opts);
      price = calculatePrice(dim.volume);
      cb({ "status" : "valid model after rescale (too sall)", "code" : 1, "dimensions" : dim, "price" : price, "maxscale" : maxminscale.max, "minscale" : maxminscale.min, "opts" : opts});
    }
    else
    {
      price = calculatePrice(dim.volume);
      cb({ "status" : "valid model", "code" : 0, "dimensions" : dim, "price" : price, "maxscale" : maxminscale.max, "minscale" : maxminscale.min,  "opts" : opts});
    }
  }
  /*else if(ext.toLowerCase() === '.obj')
  {
    // not implemented yet
    cb({ "status" : "invalid format", "code" : -4 });
  }*/
  else
  {
    cb({ "status" : "invalid format", "code" : -4 });
  }
};

/**
 * Return dimensions of a mesh
 * {length, width, height, volume, area}
 */
var getDimensions = function(geometry)
{
  var boundingBox = geometry.boundingBox
    , dimensions  = {}
    ;
  dimensions.length = (boundingBox.max.x - boundingBox.min.x);
  dimensions.width  = (boundingBox.max.y - boundingBox.min.y);
  dimensions.height = (boundingBox.max.z - boundingBox.min.z);
  dimensions.volume = ThreeUtils.calculateVolume(geometry);
  dimensions.area   = ThreeUtils.calculateArea(geometry);
  return dimensions;
};

/**
 * Apply scale to dimensions and return new dimensions
 */
var applyScale = function(dim, opts)
{
  var unit_scale = 1
    , newDim     = {}
    ;
  if(opts.unit === "cm") unit_scale = 10;

  newDim.length = dim.length * unit_scale * opts.scale;
  newDim.width  = dim.width * unit_scale * opts.scale;
  newDim.height = dim.height * unit_scale * opts.scale;
  newDim.area   = round2(dim.area * Math.pow(unit_scale * opts.scale,2));
  newDim.volume = round2(dim.volume * Math.pow(unit_scale * opts.scale,3));

  return newDim;
};

/**
 * Get min/max scale
 */
var getMinMaxScale = function(dim)
{
  var maxScaleW = MAX_DIM.width / dim.width
    , maxScaleL = MAX_DIM.length / dim.length
    , maxScaleH = MAX_DIM.height / dim.height
    ;

  var minScaleW = MIN_DIM.width / dim.width
    , minScaleL = MIN_DIM.length / dim.length
    , minScaleH = MIN_DIM.height / dim.height
    ;

  var maxScale = parseFloat(Math.min(maxScaleW, maxScaleL, maxScaleH).toFixed(1));
  var minScale = parseFloat(Math.min(minScaleW, minScaleL, minScaleH).toFixed(1));

  return {'max' : maxScale, 'min' : minScale};
};

var calculatePrice = function(volume)
{
  return volume * PRICE_MM3; // volume * price of 1 mm3
};

/**
 * Round float to 2 decimals
 */
var round2 = function(val)
{
  return parseFloat(val.toFixed(2));
};
