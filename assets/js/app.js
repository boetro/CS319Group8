require.config({
  paths: {
    "jquery": "https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min"
  }
});

/**
 This will look for a file names myfile.js within the same directory as this file,
 and then it is referenced as a callback
*/
/*
require(['myfile'], function(myFile) {
  myFile.init();
});
*/

require(['TestModule'], function(test) {
  test.init();
});