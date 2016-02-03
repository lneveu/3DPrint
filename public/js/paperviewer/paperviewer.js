/* jshint laxcomma:true, laxbreak:true*/
PaperViewer = function()
{
    // vars
    var scope              = this
        , container        = null
        , container_width  = null
        , container_height = null

        , camera           = null
        , scene            = null
        , renderer         = null
        , color            = 0x1b1c1e

        , grid             = null
        , color_grid       = 0xDEDEDE

        , ground           = null
        , ground_x         = 2000
        , ground_y         = 2000

        , geometry         = null
        , mesh             = null
        , size             = null

        , reg_ext          = /(?:\.([^.]+))?$/
        ;

    this.init = function(containerID, path, ext)
    {
        container = document.getElementById(containerID);
        container_width = container.offsetWidth;
        container_height = container.offsetHeight;

        // create camera
        camera = new THREE.PerspectiveCamera(45, container_width / container_height, 1, 100000);
        camera.position.set(0, 0, 0);

        // setup controls
        controls = new THREE.NormalControls(camera,container);
        controls.maxDistance = 100;

        // create scene
        scene = new THREE.Scene();

        // create ground
        var groundMaterial = new THREE.MeshPhongMaterial({color: color});
        var division_x = Math.floor(ground_x / 10);
        var division_y = Math.floor(ground_y / 10);
        plane = new THREE.Mesh(new THREE.PlaneGeometry(ground_x, ground_y, division_x, division_y), groundMaterial);
        plane.name = "ground";
        plane.receiveShadow = true;
        scene.add(plane);

        // load model
        var loader = null;
        if(ext === "stl")
        {
            loader = new THREE.STLLoader();
            loadModel(loader, path);
        }
        else if(ext === "obj")
        {
            loader = new THREE.OBJLoader();
            loadModel(loader, path);
        }
        else
        {
            console.error("Invalid format file");
        }

        // add lights
        addLights();

        // renderer
        renderer = new THREE.WebGLRenderer( { antialias: true, alpha: true	} );
        renderer.setClearColor( 0x000000, 0 );
        renderer.setPixelRatio( window.devicePixelRatio );
        renderer.setSize( container_width, container_height );
        container.appendChild( renderer.domElement );

        this.animate();

    };

    var loadModel = function(loader, file)
    {
        var material = new THREE.MeshPhongMaterial( { color: 0xdddddd, shininess: 30, shading: THREE.FlatShading } );
        loader.load(file, function ( geo )
        {
            geometry = geo;

            if(geometry.type === "BufferGeometry") // we need to transform BufferGeometry to Geometry
            {
              mesh = new THREE.Mesh(geometry, material);
              var bbox = new THREE.Box3().setFromObject(mesh);
              geometry.boundingBox = bbox;
              geometry = new THREE.Geometry().fromBufferGeometry(geometry);
            }
            else if (geometry.type === "Object3D" )
            {
                geometry = geometry.children[0].geometry;
                geometry = new THREE.Geometry().fromBufferGeometry(geometry);

                mesh = new THREE.Mesh(geometry, material);
                var bbox = new THREE.Box3().setFromObject(mesh);
                geometry.boundingBox = bbox;
            }
            else
            {
                mesh = new THREE.Mesh( geometry, material );
            }

            mesh.position.set( 0, 0, 0 );
            mesh.castShadow = true;
            mesh.receiveShadow = true;
            scene.add(mesh);

            geometry.computeBoundingSphere();
            geometry.computeBoundingBox();

            var length = mesh.geometry.boundingBox.max.x - mesh.geometry.boundingBox.min.x;
            var width = mesh.geometry.boundingBox.max.y - mesh.geometry.boundingBox.min.y;
            var height = mesh.geometry.boundingBox.max.z - mesh.geometry.boundingBox.min.z;

            size = Math.max(length, width);
            plane.position.y -= height / 2;

            // add grid helper
            grid = new THREE.GridHelper(size/2 * 4, size/2 );
            grid.setColors(color_grid, color_grid);
            grid.rotation.set(-Math.PI/2, Math.PI/2000, Math.PI);
            grid.name = "grid";
            scene.add(grid);

            // add fog
            scene.fog = new THREE.Fog(color, 1, 20 * size);

            // set maxDistance
            controls.maxDistance = 10 * size;

            // center camera
            centerCamera();
        });
    };

    this.animate = function()
    {
        requestAnimationFrame( scope.animate );
        render();
    };

    var render = function()
    {
        controls.update();
        renderer.render( scene, camera );
    };

    var addLights = function()
    {
        spotLight = new THREE.SpotLight(0xb8b8b8,1.2,0);
        spotLight.position.set(-700, 1000, 1000);
        spotLight.castShadow = false;
        scene.add(spotLight);
        pointLights = [];
        pointLight = new THREE.PointLight(0xb8b8b8,1.2,0);
        pointLight.position.set(3200, -3900, 3500);
        scene.add(pointLight);
        pointLights.push(pointLight);
    };

    var centerCamera = function()
    {
        if(geometry)
        {
            camera.lookAt(mesh.position);

            var center = computeSphereCenter(geometry);
            camera.position.x = center.x;
            camera.position.y = center.y;
            camera.position.z = center.z;

            var distance = geometry.boundingSphere.radius / Math.sin((camera.fov) * camera.aspect * (Math.PI / 360));
            var factor = -distance * 1.4;
            camera.position.y += factor;
            camera.position.z -= factor;
            camera.position.x -= factor/4;
        }
    };

    var computeSphereCenter = function(geometry)
    {
        var min_x = 0;
        var min_y = 0;
        var min_z = 0;

        var max_x = 0;
        var max_y = 0;
        var max_z = 0;

        for (var v = 0, vl = geometry.vertices.length; v < vl; v ++)
         {
           max_x = Math.max(max_x, geometry.vertices[v].x);
           max_y = Math.max(max_y, geometry.vertices[v].y);
           max_z = Math.max(max_z, geometry.vertices[v].z);

           min_x = Math.min(min_x, geometry.vertices[v].x);
           min_y = Math.min(min_y, geometry.vertices[v].y);
           min_z = Math.min(min_z, geometry.vertices[v].z);
        }
        var center_x = (max_x + min_x)/2;
        var center_y = (max_y + min_y)/2;
        var center_z = (max_z + min_z)/2;
        return new THREE.Vector3(center_x, center_y, center_z);
    };
};
