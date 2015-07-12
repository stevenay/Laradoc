class app.Model

  # this constructor takes all the parameters from Json Array
  # Like the following eg.
  #  {
  #  "name":"Angularbbb.js",
  #  "slug":"angular",
  #  "type":"angular",
  #  "version":"1.3.15",
  #  "index_path":"angular/index.json",
  #  "db_path":"angular/db.json",
  #  "links":null,
  #  "mtime":1432484970,
  #  "db_size":897948
  #  }
  constructor: (attributes) ->
    @[key] = value for key, value of attributes
