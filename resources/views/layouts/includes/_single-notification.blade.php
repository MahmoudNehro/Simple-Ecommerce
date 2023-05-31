<li class="scrollable-container media-list" id="{{$notification->id}}">
    <a class="d-flex justify-content-between" href="javascript:void(0)" onclick="readNotification({{$notification}})">
          <div class="media d-flex align-items-start">
              <div class="media-left"><i
                      class="feather icon-plus-square font-medium-5 primary"></i></div>
              <div class="media-body">
                  <h6 class="primary media-heading">{{data_get($notification,'data.title')}} {{data_get($notification,'data.order_id')}}</h6><small
                      class="notification-text"> {{data_get($notification,'data.body')}} </small>
              </div><small>
                  <time class="media-meta" datetime="2015-06-11T18:29:20+08:00">{{$notification->created_at?->diffForHumans()}}</time></small>
          </div>
      </a>
  </li>