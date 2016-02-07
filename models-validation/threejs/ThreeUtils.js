/* jshint laxcomma:true, laxbreak:true*/
var THREE       = require('three')
  , fs          = require('fs')
  , OBJLoader   = require('./OBJLoader.js')
  , STLLoader   = require('./STLLoader.js')
  ;

module.exports =
{
  calculateVolume : function(geometry)
  {
    var volume = 0.0;
    for(var i = 0; i < geometry.faces.length; i++){
        var Pi = geometry.faces[i].a;
        var Qi = geometry.faces[i].b;
        var Ri = geometry.faces[i].c;

        var P = new THREE.Vector3(geometry.vertices[Pi].x, geometry.vertices[Pi].y, geometry.vertices[Pi].z);
        var Q = new THREE.Vector3(geometry.vertices[Qi].x, geometry.vertices[Qi].y, geometry.vertices[Qi].z);
        var R = new THREE.Vector3(geometry.vertices[Ri].x, geometry.vertices[Ri].y, geometry.vertices[Ri].z);
        volume += volumeOfT(P, Q, R);
    }
    return Math.abs(volume);
  }

  , calculateArea : function(geometry)
  {
    var area = 0.0;
    for(var i = 0; i < geometry.faces.length; i++)
    {
      var Pi = geometry.faces[i].a;
      var Qi = geometry.faces[i].b;
      var Ri = geometry.faces[i].c;

      var P = new THREE.Vector3(geometry.vertices[Pi].x, geometry.vertices[Pi].y, geometry.vertices[Pi].z);
      var Q = new THREE.Vector3(geometry.vertices[Qi].x, geometry.vertices[Qi].y, geometry.vertices[Qi].z);
      var R = new THREE.Vector3(geometry.vertices[Ri].x, geometry.vertices[Ri].y, geometry.vertices[Ri].z);
      area += areaofT(P, Q, R);
    }
    return area;
  }

  /**
   * Get ThreeJS geometry from OBJ file
   */
  , getGeometryFromOBJ : function(file)
  {
    var buf = fs.readFileSync(file);
    var object3d = OBJLoader.parse(buf.toString("UTF-8"));

    if(object3d.children.length > 0)
    {
      var geometry =  new THREE.Geometry().fromBufferGeometry(object3d.children[0].geometry);
      geometry.computeBoundingBox();
      return geometry;
    }
    else
    {
      return {};
    }
  }

  /**
   * Get ThreeJS geometry from STL file
   */
  , getGeometryFromSTL : function(file)
  {
    var buf = fs.readFileSync(file);
    var geometry = STLLoader.parse(buf);

    if(geometry.type === "BufferGeometry") // we need to transform BufferGeometry to Geometry
    {
      geometry = new THREE.Geometry().fromBufferGeometry(geometry);
      geometry.computeBoundingBox();
    }
    return geometry;
  }
};

function volumeOfT(p1, p2, p3)
{
    var v321 = p3.x*p2.y*p1.z;
    var v231 = p2.x*p3.y*p1.z;
    var v312 = p3.x*p1.y*p2.z;
    var v132 = p1.x*p3.y*p2.z;
    var v213 = p2.x*p1.y*p3.z;
    var v123 = p1.x*p2.y*p3.z;
    return (-v321 + v231 + v312 - v132 - v213 + v123)/6.0;
}

function areaofT(p1, p2, p3)
{

  var sub1 = new THREE.Vector3().subVectors(p3,p1); //p3 - p1
  var sub2 = new THREE.Vector3().subVectors(p3,p2); //p3 - p2
  var crossP = new THREE.Vector3().crossVectors(sub1,sub2); //sub1 x sub2
  var area = Math.sqrt( Math.pow(crossP.x,2) + Math.pow(crossP.y,2) + Math.pow(crossP.z,2) );
  return area/2;
}
