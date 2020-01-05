export var userRoles = (key) => {
   var config = {
      '1': 'admin',
      '2': 'usaha',
      '3': 'member'
   }
   return config[key]
}