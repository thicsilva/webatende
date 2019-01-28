<template>
  <li class="nav-item dropdown">
    <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
      <i class="mdi mdi-bell-outline"></i>
      <span class="count" v-if="notifications.length>0">{{notifications.length}}</span>
    </a>
    <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown" v-if="notifications.length>0">
      <div :key="notification.id" v-for="notification in notifications">
        <div class="dropdown-divider"></div>
        <a class="dropdown-item preview-item" :href="notification.url">
          <div class="preview-thumbnail">
            <img :src="notification.avatar" alt="image" class="profile-pic">
          </div>
          <div class="preview-item-content flex-grow">
            <h6 class="preview-subject ellipsis font-weight-medium text-dark">{{notification.title}}
              <span class="float-right font-weight-light small-text"><timeago :datetime="notification.time"></timeago></span>
            </h6>
            <p class="font-weight-light small-text">
              {{notification.body}}
            </p>
          </div>
        </a>
      </div>
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
      props: ['user_id', 'base_url', 'sound_notification'],
      mounted() {
        console.log('montado')
        var s= document.getElementById('sound-notification');
        Echo.channel('events')
          .listen('CallCreated', (call)=>{
            if (this.user_id == call.toUser.id){
              if (this.sound_notification==1){
                s.play();
              }
              this.notifications.unshift({
                title: "Novo chamado",
                body: call.customer.name,
                avatar:  this.base_url + 'uploads/users/' + call.fromUser.avatar,
                url: this.base_url + 'call/show/' + call.id,
                time: new Date(),
              })
            }
          })
          .listen('ScheduleCreated', (schedule)=>{
            if (this.user_id == schedule.toUser.id){
              if (this.sound_notification==1){
                console.log('tocando som');
                s.play();
              }
              this.notifications.unshift({
                title: "Novo agendamento",
                body: schedule.customer.name,
                avatar: this.base_url + 'uploads/users/' + schedule.fromUser.avatar,
                url: this.base_url + 'schedule/show/' + schedule.id,
                time: new Date(),
              })
            }
          })
      },
      data(){
        return {
          notifications: []
        }
      },
    }
</script>
