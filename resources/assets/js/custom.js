$(document.body).delegate('[type="checkbox"][readonly="readonly"]', 'click', function(e) {
    e.preventDefault();
});
