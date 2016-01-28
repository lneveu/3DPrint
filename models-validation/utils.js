/* jshint laxcomma:true, laxbreak:true*/
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
};
