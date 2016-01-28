/* jshint laxcomma:true, laxbreak:true*/
var PythonShell   = require('python-shell')
    , fs          = require('fs')
    , path        = require('path')
    , utils       = require('../utils.js')
    , SCRIPT_PATH = __dirname + '/stl_normalize'
    , STLLoader   = require('../threejs/STLLoader.js')
    , ThreeUtils  = require('../threejs/ThreeUtils.js')
    , THREE       = require('three')
    , config      = require('../config.json')
    ;

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
  var ext            = path.extname(file)
    , geometry       = null
    , price          = null
    , displayableDim = null
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

    var origin_dim = getDimensions(geometry); // get origin dimensions
    maxminscale = getMinMaxScale(origin_dim, opts.unit); // get MAX & MIN scale of origin dimensions according to unit

    if( isTooBig(origin_dim, opts) ) // model is too big
    {
      opts.scale = maxminscale.max; // set current scale to maxscale
      dim = applyScale(origin_dim, opts.scale); // rescale the model with maxscale (with current unit)
      price = calculatePrice(dim.volume, opts.unit); // calculate price according to the volume
      displayableDim = getDimensionsForDisplay(dim, opts.unit); // get dimensions according to the unit

      cb({ "status" : "valid model after rescale (too big)", "code" : 2, "dimensions" : displayableDim, "price" : price, "maxscale" : maxminscale.max, "minscale" : maxminscale.min, "opts" : opts});
    }
    else if( isTooSmall(origin_dim, opts) ) // model is too small
    {
      opts.scale = maxminscale.min; // set current scale to minscale
      dim = applyScale(origin_dim, opts.scale);
      price = calculatePrice(dim.volume, opts.unit);
      displayableDim = getDimensionsForDisplay(dim, opts.unit);

      cb({ "status" : "valid model after rescale (too sall)", "code" : 1, "dimensions" : displayableDim, "price" : price, "maxscale" : maxminscale.max, "minscale" : maxminscale.min, "opts" : opts});
    }
    else
    {
      dim = applyScale(origin_dim, opts.scale);
      price = calculatePrice(dim.volume, opts.unit);
      displayableDim = getDimensionsForDisplay(dim, opts.unit);

      cb({ "status" : "valid model", "code" : 0, "dimensions" : displayableDim, "price" : price, "maxscale" : maxminscale.max, "minscale" : maxminscale.min,  "opts" : opts});
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
 * Return dimensions of a mesh (dimensions have not unit)
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
var applyScale = function(dim, scale)
{
  var newDim = {};
  newDim.length = dim.length * scale;
  newDim.width  = dim.width * scale;
  newDim.height = dim.height * scale;
  newDim.area   = utils.round2(dim.area * Math.pow(scale,2));
  newDim.volume = utils.round2(dim.volume * Math.pow(scale,3));

  return newDim;
};

/**
 * Get min/max scale according to MIN and MAX dimensions and the unit
 */
var getMinMaxScale = function(dim, unit)
{
  var unit_scale = getUnitScale(unit);

  var maxScaleW = config.MAX_DIM.width / (dim.width * unit_scale)
    , maxScaleL = config.MAX_DIM.length / (dim.length * unit_scale)
    , maxScaleH = config.MAX_DIM.height / (dim.height * unit_scale)
    ;

  var minScaleW = config.MIN_DIM.width / (dim.width * unit_scale)
    , minScaleL = config.MIN_DIM.length / (dim.length * unit_scale)
    , minScaleH = config.MIN_DIM.height / (dim.height * unit_scale)
    ;

  var maxScale = utils.truncateDecimals(Math.min(maxScaleW, maxScaleL, maxScaleH), 2);
  var minScale = utils.truncateDecimals(Math.min(minScaleW, minScaleL, minScaleH), 2);
  if(maxScale < 0.1) maxScale = 0.1;
  if(minScale < 0.1) minScale = 0.1;

  return {'max' : maxScale, 'min' : minScale};
};

/**
 * Check if dimensions of the model are > MAXDIM according to the scale & the unit
 */
var isTooBig = function(dim, opts)
{
    var unit_scale = getUnitScale(opts.unit);
    var tmp_dim = applyScale(dim, opts.scale);

    return (tmp_dim.length * unit_scale > config.MAX_DIM.length || tmp_dim.width * unit_scale > config.MAX_DIM.width || tmp_dim.height * unit_scale > config.MAX_DIM.height);
};

/**
 * Check if dimensions of the model are < MINDIM according to the scale & the unit
 */
var isTooSmall = function(dim, opts)
{
    var unit_scale = getUnitScale(opts.unit);
    var tmp_dim = applyScale(dim, opts.scale);

    return (tmp_dim.length * unit_scale < config.MIN_DIM.length || tmp_dim.width * unit_scale < config.MIN_DIM.width || tmp_dim.height * unit_scale < config.MIN_DIM.height);
};

/**
 * Calculate price according to the volume
 */
var calculatePrice = function(volume, unit)
{
  var unit_scale = getUnitScale(unit);
  return (volume * Math.pow(unit_scale,3) * config.PRICE_MM3) + config.PRICE_BASE; // volume * price of 1 mm3
};

/**
 * Return dimensions that will be displayed
 */
var getDimensionsForDisplay = function(dim, unit)
{
  var unit_scale = getUnitScale(unit)
    , newDim     = {}
    ;

  newDim.length = dim.length / unit_scale;
  newDim.width  = dim.width / unit_scale;
  newDim.height = dim.height / unit_scale;
  newDim.area   = utils.round2(dim.area / Math.pow(unit_scale,2));
  newDim.volume = utils.round2(dim.volume / Math.pow(unit_scale,3));

  return newDim;
};

/**
 * Get unit scale by unit
 */
var getUnitScale = function(unit)
{
  var unit_scale = 1;
  if(unit === "cm") unit_scale = 10;
  return unit_scale;
};
