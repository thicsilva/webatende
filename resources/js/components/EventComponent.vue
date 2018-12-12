<template>
  <li class="nav-item dropdown">
    <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
      <i class="mdi mdi-file-outline"></i>
      <span class="count">7</span>
    </a>
    <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
      <div class="dropdown-item">
        <p class="mb-0 font-weight-normal float-left">You have 7 unread mails
        </p>
        <span class="badge badge-info badge-pill float-right">View all</span>
      </div>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item preview-item">
        <div class="preview-thumbnail">
          <img src="/images/faces/face4.jpg" alt="image" class="profile-pic">
        </div>
        <div class="preview-item-content flex-grow">
          <h6 class="preview-subject ellipsis font-weight-medium text-dark">David Grey
            <span class="float-right font-weight-light small-text">1 Minutes ago</span>
          </h6>
          <p class="font-weight-light small-text">
            The meeting is cancelled
          </p>
        </div>
      </a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item preview-item">
        <div class="preview-thumbnail">
          <img src="/images/faces/face2.jpg" alt="image" class="profile-pic">
        </div>
        <div class="preview-item-content flex-grow">
          <h6 class="preview-subject ellipsis font-weight-medium text-dark">Tim Cook
            <span class="float-right font-weight-light small-text"><timeago :datetime="new Date()"></timeago></span>
          </h6>
          <p class="font-weight-light small-text">
            New product launch
          </p>
        </div>
      </a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item preview-item">
        <div class="preview-thumbnail">
          <img src="/images/faces/face3.jpg" alt="image" class="profile-pic">
        </div>
        <div class="preview-item-content flex-grow">
          <h6 class="preview-subject ellipsis font-weight-medium text-dark"> Johnson
            <span class="float-right font-weight-light small-text">18 Minutes ago</span>
          </h6>
          <p class="font-weight-light small-text">
            Upcoming board meeting
          </p>
        </div>
      </a>
    </div>
  </li>
</template>

<script>
  import VueTimeago from 'vue-timeago'

  Vue.use(VueTimeago, {
    name: 'Timeago', // Component name, `Timeago` by default
    locale: 'pt', // Default locale
    // We use `date-fns` under the hood
    // So you can use all locales from it
    locales: {
      'pt-BR': require('date-fns/locale/pt'),
    }
  })
</script>
