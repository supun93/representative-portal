var jsdivs = document.getElementsByClassName('code-js');
var codes = [];
for(var i=0; i<jsdivs.length; i++){
    var el = jsdivs[i];
    var cm = CodeMirror.fromTextArea(el, {
        lineNumbers: true,
        theme: "monokai",
        viewportMargin: Infinity,
        mode: "javascript"
    });
    cm.setSize('100%', el.value.split('\n').length * 20 + 10);
}

var runDivs = document.getElementsByClassName('run');
for(var i=0; i<runDivs.length; i++){
    var el = runDivs[i];
    el.onclick = function(e){
        var cm = e.target.parentNode.getElementsByClassName('CodeMirror')[0].CodeMirror;
        eval(cm.getValue());

    };
}