# wangEditor-fullscreen-plugin
富文本编辑器wangEditor的全屏插件，适用于V3

使用方法：
1. 依赖jquery或者zepto，须先引入jquery或zepto。有兴趣可修改为无依赖版本，代码很简单。
2. 引入wangEditor-fullscreen-plugin.css和wangEditor-fullscreen-plugin.js两个文件。
3. 在wangEditor的create方法调用后，再调用插件的初始化方法，如：

      var E = window.wangEditor;
      var editor = new E('#editor');
      editor.create();
      E.fullscreen.init('#editor');
      
4. 完成。
