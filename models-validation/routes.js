/* jshint laxcomma:true, laxbreak:true*/
var validator = require('./validation/validator.js');

module.exports =
{
    /**
     * Check non-manifold AND dimensions (STL/OBJ file)
     * POST request must contain a JSON object: { 'file' : 'path/to/file/mymodel.stl', ['opts' : { 'scale' : 1, 'unit' : 'cm'}] }
     * @return a JSON object with the result of the validation
     *  response format: { 'status' : <status>, 'code' : <code> }
     *  status: 'bad request' or 'valid' or 'invalid'
     *  code:
     *       0  -> model is valid
     *      -1  -> bad request / bad parameters
     *      -2  -> file not exists
     *      -3  -> model is not valid (contains non-manifold elements)
     *      -4  -> format is not valid
     */
    checkAll : function(req, res)
    {
        if(typeof req.body === 'undefined' || typeof req.body.file === 'undefined')
        {
            res.send( { 'status' : 'bad request', 'code' : -1 });
        }
        else
        {
            var opts;
            if( typeof req.body.opts == 'undefined'
                || typeof req.body.opts.scale == 'undefined'
                || typeof req.body.opts.unit === 'undefined')
              {
                opts = { 'scale' : 1, 'unit' : 'mm' };
              }
              else
              {
                opts = req.body.opts;
              }

            // execute validation
            validator.checkAll(req.body.file, opts, function(result)
            {
                // send result
                res.send(result);
            });
        }
    }

    /**
     * Check dimensions (STL/OBJ file)
     * POST request must contain a JSON object: { 'file' : 'path/to/file/mymodel.stl' }
     * @return a JSON object with the result of the validation
     */
    , checkDimensions : function(req, res)
    {
      if(typeof req.body === 'undefined' || typeof req.body.file === 'undefined')
      {
          res.send( { 'status' : 'bad request', 'code' : -1 });
      }
      else
      {
        var opts;
        if( typeof req.body.opts == 'undefined'
            || typeof req.body.opts.scale == 'undefined'
            || typeof req.body.opts.unit === 'undefined')
          {
            opts = { 'scale' : 1, 'unit' : 'mm' };
          }
          else
          {
            opts = req.body.opts;
          }

        // execute validation
        validator.checkDimensions(req.body.file, opts, function(result)
        {
            // send result
            res.send(result);
        });
      }
    }
};
