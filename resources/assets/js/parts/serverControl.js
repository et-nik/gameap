if( document.getElementById("serverControl") ) {

    var server = Vue.component('server', {
        functional: true,
        props: ['serverId'],
        // render: function(h) {
        //     console.log('azaza' + this.serverId);
        // }
        methods: {
            startServer: function() {
                console.log(this);
                // alert('К запуску готов, капитан! ServerId: ' + this.server.serverId);
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

    // Vue.mixin({
    //     data: function () {
    //         return {
    //             // serverId: this.serverId,
    //             watchTaskId: 0
    //         };
    //     },
    //     methods: {
    //         startServer: function() {
    //             console.log(this);
    //             // alert('К запуску готов, капитан! ServerId: ' + this.server.serverId);
    //         },
    //         stopServer: function() {
    //
    //         },
    //         restartServer: function() {
    //
    //         },
    //         updateServer: function() {
    //
    //         },
    //         watchTask: function() {
    //
    //         }
    //     }
    // });
}