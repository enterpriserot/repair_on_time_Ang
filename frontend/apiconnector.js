app.factory("services", ['$http','$q', function ($http, $q) {
    var serviceBase = '/repair_on_time_Ang/backend/index.php?module=';
    var obj = {};

        obj.get = function (module, functi) {
            var defered=$q.defer();
            var promise=defered.promise;
            console.log("GET 1");
            $http({
                  method: 'GET',
                  url: serviceBase + module + '&function=' + functi
                  // url: serviceBase + "technicians&function=maploader"
              }).success(function(data, status, headers, config) {
                console.log('GET success: ');
                console.log(data);
                console.log(" config: ");
                console.log(config);
                 defered.resolve(data);
              }).error(function(data, status, headers, config) {
                console.log("ERROR GET"+data);
                 defered.reject(data);
              });
            return promise;
        };
        //
        // obj.get = function (module, functi, dada) {
        //     var defered=$q.defer();
        //     var promise=defered.promise;
        //     console.log("GET 2");
        //     $http({
        //           method: 'GET',
        //           url: serviceBase + module + '&function=' + functi + '&param=' + dada
        //       }).success(function(data, status, headers, config) {
        //          //console.log(data);
        //          defered.resolve(data);
        //       }).error(function(data, status, headers, config) {
        //          defered.reject(data);
        //       });
        //     return promise;
        // };
        //
        // obj.get = function (module, functi, dada, dada2) {
        //     var defered=$q.defer();
        //     var promise=defered.promise;
        //     console.log("GET 3 module: "+module+ " function: "+functi+ " dada: "+dada+" dada2: "+dada2);
        //     $http({
        //           method: 'GET',
        //           url: serviceBase + module + '&function=' + functi + '&param=' + dada + '&param2=' + dada2
        //           // url: serviceBase + "technicians&function=maploader"
        //       }).success(function(data, status, headers, config) {
        //         //  console.log('GET 3 success: '+data+" status: "+status+" headers: "+headers+" config: "+config);
        //          console.log('GET 3 success: ');
        //          console.log(data);
        //          console.log(" config: ");
        //          console.log(config);
        //          defered.resolve(data);
        //       }).error(function(data, status, headers, config) {
        //          console.log('GET 3 error: '+data);
        //          defered.reject(data);
        //       });
        //     return promise;
        // };

        obj.post = function (module, functi, dada) {
          var defered=$q.defer();
          var promise=defered.promise;
          $http({
                method: 'POST',
                url: serviceBase + module + '&function=' + functi,
                data: dada
            }).success(function(data, status, headers, config) {
      	       defered.resolve(data);
            }).error(function(data, status, headers, config) {
               defered.reject(data);
            });
          return promise;
        };

        obj.put = function (module, functi, dada) {
          var defered=$q.defer();
          var promise=defered.promise;
          $http({
                method: 'PUT',
                url: serviceBase + module + '&function=' + functi,
                data: dada
            }).success(function(data, status, headers, config) {
      	       defered.resolve(data);
            }).error(function(data, status, headers, config) {
               defered.reject(data);
            });
          return promise;
        };

        obj.delete = function (module, functi, dada) {
            var defered=$q.defer();
            var promise=defered.promise;
            $http({
                  method: 'DELETE',
                  url: serviceBase + module + '&function=' + functi + '&param=' + dada
              }).success(function(data, status, headers, config) {
                 //console.log(data);
                 defered.resolve(data);
              }).error(function(data, status, headers, config) {
                 defered.reject(data);
              });
            return promise;
        };
    return obj;
}]);
