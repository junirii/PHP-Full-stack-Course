const { defineConfig } = require('@vue/cli-service');
const path = require("path");

module.exports = defineConfig({
  outputDir: path.resolve('../ChatServer/public'),
  transpileDependencies: true,
  lintOnSave: false,
  devServer: {
    proxy: {
      '/': {
        target: 'http://localhost'
      }
    }
  }
})
