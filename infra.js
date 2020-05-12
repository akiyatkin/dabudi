import { Controller } from '/vendor/infrajs/controller/src/Controller.js'

Controller.wait('init').then(async () => {
	await import('./init.js')
})