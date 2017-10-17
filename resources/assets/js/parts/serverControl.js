if( document.getElementById("serverControl") ) {
    Vue.mixin({
        data: function () {
            return {
                watchTaskId: 0
            };
        },
        methods: {
            startServer: function() {
                alert('К запуску готов, капитан! ServerId: ' + page.serverId);
            },
            stopServer: function() {

            },
            restartServer: function() {

            },
            updateServer: function() {

            },
            watchTask: function() {

            }
        }
    });
}