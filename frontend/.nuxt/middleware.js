const middleware = {}

middleware['logged'] = require('../middleware/logged.js')
middleware['logged'] = middleware['logged'].default || middleware['logged']

export default middleware
