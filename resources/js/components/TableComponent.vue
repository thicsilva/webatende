<template>
<table class="table table-striped" id="table">
  <thead>
    <tr>
      <th>Cliente</th>
      <th>Status</th>
      <th>Para</th>
      <th>Data</th>
      <th>Ações</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="call in calls" :key="call.id">
      <td>
        {{ call.customer.name }}
      </td>
      <td v-if="call.status">
        <span class="status-indicator online"></span>
        Encerrada
      </td>
      <td v-else>
        <span class="status-indicator away"></span>
        Aberta
      </td>
      <td> {{ call.to_user.name }}</td>
      <td> {{ formatDate(call.created_at) }}</td>
      <td>
        <div class="btn-group" role="group">
          <a href="#" class="btn btn-inverse-primary">
            <i class="mdi mdi-pencil"></i>
            Editar
          </a>
        </div>
        <div class="btn-group" role="group">
          <button class="btn btn-inverse-danger" type="submit" @click="removeCall(call)">
            <i class="mdi mdi-delete"></i>
              Excluir
          </button>

        </div>
      </td>
    </tr>
  </tbody>
</table>
</template>
<script>
  import moment from 'moment';
  Vue.use(moment);
  export default{
    props: ['current'],
    data() {
      return {
        calls: [],
        search: '',
      }
    },
    mounted() {
      this.fetchCalls();
      this.listenChanges();
      console.log('tabela montada');
    },
    methods: {
      fetchCalls() {
        axios.get('/call/fetchall').then((response) => {
          this.calls = response.data;
        })
      },
      listenChanges() {
        Echo.channel('calls')
        .listen('CallCreated', (e) => {
          var call = this.calls.find((call) => call.id === e.id);
          if (!call) {
            calls.unshift(call);
          }
        })
      },
      removeCall(call) {
        axios.delete('/call/'+call.id)
          .then(res => {
            if (res.data === 'deleted'){
              this.calls.splice(this.calls.indexOf(call), 1);
            }
          }).catch(err => {
            console.log(err);
          })
      },
      formatDate(date){
        return moment(date).format('DD/MM/YYYY');
      }
    }
  }
</script>
