(function () {
    window.onload=function(){
        var d=document.createElement('div');
        d.classList.add('svg-container');
        d.classList.add('hidden');
        d.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" id="svg-star" version="1" viewBox="0 0 444 424">' +
            '<path d="M96 415a8 8 0 0 1-5-1 8 8 0 0 1-3-8l24-136-100-97a8 8 0 0 1 5-13l137-20 61-125a8 8 0 0 1 7-4c3 0 6 2 7 4l61 125 138 20a8 8 0 0 1 4 13l-99 97 23 136c1 3-1 6-3 8a8 8 0 0 1-8 0l-123-64-123 64-3 1z"/>' +
            '</svg>';
        document.body.appendChild(d);
    }
})();