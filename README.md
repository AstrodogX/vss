# Very Simple Shop Basket Example
An example project of a simple shop basket.
Demonstrates using Symphony 6.3 for backend (Doctrine + Forms + Validation) and frontend (Webpack Encore + Stimulus + UX Turbo + Bootstrap).

Supposed to be launched from the subdirectory `vss`. Otherwise, you need to edit the file `webpack.config.js`:
```
// Uncomment this line
.setPublicPath('/build')
// And comment these lines
.setPublicPath('/vss/public/build')
.setManifestKeyPrefix('build')
```