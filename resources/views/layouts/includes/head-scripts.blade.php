<script src="https://unpkg.com/feather-icons"></script>
<script>
    function decrementNotification(notificationElementId) {
        let notificationCount = document.getElementById(notificationElementId);
        notificationCount.innerText = parseInt(notificationCount.innerText) - 1;
    }

    function readNotification(notification) {
        let url = "{{ route('admin.read-notification', ['notification' => ':notification']) }}";
        url = url.replace(':notification', notification.id);
        $.ajax({
            url: url,
            type: "GET",
            data: {
                "_token": "{{ csrf_token() }}",
            },
            success: function(response) {
                let notificationElement = document.getElementById(notification.id);
                notificationElement.remove();
                decrementNotification('notification-count');
                decrementNotification('notification-count-label');
            },
            error: function(response) {
                console.log(response);
            }
        });
    }
</script>
