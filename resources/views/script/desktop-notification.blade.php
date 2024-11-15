<script>
    function desktopNotification(title,body){
        console.log("desktopNotification");
        if (Notification.permission !== "granted"){
            console.log('Get Permission');
            Notification.requestPermission();
        }

        else {
            var notification = new Notification(title, {
                icon: "{{ url('resources/img/doh.png') }}",
                body: body,
            });

            notification.onclick = function () {
                window.open("{{ url('/') }}");
            };
        }
    }
</script>