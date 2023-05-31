<!-- BEGIN: Vendor JS-->
<script src="{{ asset('assets/js/vendors.min.js') }}"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="{{ asset('assets/js/app-menu.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="{{ asset('assets/js/components.js') }}"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<!-- END: Page JS-->
<!-- BEGIN: Page Vendor JS-->
<script src="{{ asset('assets/js/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatables.bootstrap4.min.js') }}"></script>

<!-- END: Page Vendor JS-->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>


<!-- BEGIN: Page JS-->
<script src="{{ asset('assets/js/data-list-view.js') }}"></script>
<!-- END: Page JS-->
<script>
    feather.replace();
</script>
<script type="module">
    Echo.private('App.Models.User.' + "{{ Auth::user()->id }}")
    .notification((notification) => {
        new Notification(
            notification.title,
            {
                body: notification.body,
                vibrate: [200, 100, 200, 100, 200, 100, 200],
                icon: `{{ asset('assets/images/logo.png') }}`,
                data: {
                    dateOfArrival: Date.now(),
                    primaryKey: 1
                },
            }
        );
        incrementNotification('notification-count');
        incrementNotification('notification-count-label');
        createNewNotificationElement(notification);

    }).error((error) => {
       Swal.fire({
            title: 'Error!',
            text: 'Something went wrong!',
            icon: 'error',
            confirmButtonText: 'Ok'
        })
    });

    function incrementNotification(notificationElementId) {
        let notificationCount = document.getElementById(notificationElementId);
        notificationCount.innerText = parseInt(notificationCount.innerText) + 1;
    }
    function createNewNotificationElement(notification)
    {
        var liElement = document.createElement('li');
        liElement.className = 'scrollable-container media-list';
        liElement.id = notification.id;

        var aElement = document.createElement('a');
        aElement.className = 'd-flex justify-content-between';
        aElement.href = 'javascript:void(0)';
        aElement.onclick = function() {
        readNotification(notification);
        };

        var divElement = document.createElement('div');
        divElement.className = 'media d-flex align-items-start';

        var mediaBodyElement = document.createElement('div');
        mediaBodyElement.className = 'media-body';
        var h6Element = document.createElement('h6');
        h6Element.className = 'primary media-heading';
        h6Element.textContent = notification.title + ' ' + notification.order_id;
        var smallElement = document.createElement('small');
        smallElement.className = 'notification-text';
        smallElement.textContent = notification.body;
        mediaBodyElement.appendChild(h6Element);
        mediaBodyElement.appendChild(smallElement);

        var smallTimeElement = document.createElement('small');
        var timeElement = document.createElement('time');
        timeElement.className = 'media-meta';
        timeElement.setAttribute('datetime', notification.created_at);
        timeElement.textContent = notification.created_at;
        smallTimeElement.appendChild(timeElement);

        divElement.appendChild(mediaBodyElement);
        divElement.appendChild(smallTimeElement);

        aElement.appendChild(divElement);
        liElement.appendChild(aElement);

        var container = document.getElementById('notification-container');
        var notificationHeader = document.getElementById('notification-header');

        container.insertBefore(liElement, notificationHeader.nextSibling);

    }
  
</script>
