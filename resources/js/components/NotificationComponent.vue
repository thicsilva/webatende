<template>
  <li class="nav-item dropdown">
    <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
      <i class="mdi mdi-bell-outline"></i>
      <span class="count">4</span>
    </a>
    <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
      <a class="dropdown-item preview-item">
        <div class="preview-thumbnail">
          <div class="preview-icon bg-success">
            <i class="mdi mdi-alert-circle-outline mx-0"></i>
          </div>
        </div>
        <div class="preview-item-content">
          <h6 class="preview-subject font-weight-medium text-dark">Application Error</h6>
          <p class="font-weight-light small-text">
            Just now
          </p>
        </div>
      </a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item preview-item">
        <div class="preview-thumbnail">
          <div class="preview-icon bg-warning">
            <i class="mdi mdi-comment-text-outline mx-0"></i>
          </div>
        </div>
        <div class="preview-item-content">
          <h6 class="preview-subject font-weight-medium text-dark">Settings</h6>
          <p class="font-weight-light small-text">
            Private message
          </p>
        </div>
      </a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item preview-item">
        <div class="preview-thumbnail">
          <div class="preview-icon bg-info">
            <i class="mdi mdi-email-outline mx-0"></i>
          </div>
        </div>
        <div class="preview-item-content">
          <h6 class="preview-subject font-weight-medium text-dark">New user registration</h6>
          <p class="font-weight-light small-text">
            2 days ago
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
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
