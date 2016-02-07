/* jshint laxcomma:true, laxbreak:true*/
var crypto = require('crypto');

module.exports =
{
  /**
   * Truncate decimals
   */
  truncateDecimals : function(num, digits)
  {
    var re = new RegExp("(\\d+\\.\\d{" + digits + "})(\\d)"),
          m = num.toString().match(re);
      return m ? parseFloat(m[1]) : num.valueOf();
  }

  /**
   * Round float to 2 decimals
   */
  , round2 : function(val)
  {
    return parseFloat(val.toFixed(2));
  }

  /**
   * Get str checksum
   */
  , checksum : function(str)
  {
    return crypto
        .createHash('md5')
        .update(str, 'utf8')
        .digest('hex');
  }
};
