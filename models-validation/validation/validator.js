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
  'length'   : 0.1
  , 'width'  : 0.1
  , 'height' : 0.1
};

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
                          result.opts = opts; // add scale & unit
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
              result.opts = opts; // add scale & unit
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
 * Check and return dimensions
 */
var verif_dimensions = function(file, opts, cb)
{
  var ext      = path.extname(file)
    , geometry = null
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

    if(dim.length < MAX_DIM.length && dim.width < MAX_DIM.width && dim.height < MAX_DIM.height)
    {
      cb({ "status" : "valid model", "code" : 0, "dimensions" : dim });
    }
    else
    {
      cb({ "status" : "invalid model - dimensions are not valid", "code" : -5, "dimensions" : dim });
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
  newDim.area   = dim.area * Math.pow(unit_scale * opts.scale,2);
  newDim.volume = dim.volume * Math.pow(unit_scale * opts.scale,3);

  return newDim;
};
