<template>
  <div>
      <div class="card col-md-8 offset-md-2" style="margin-top: 20px;">
          <div class="card-header">
            <div style="display:flex; justify-content: space-between;">
                <a id="create_form_icon" href="#" 
                  class="btn btn-lg btn-primary" 
                  @click="openModal"
                 >
                    <i class="plus icon"></i>Send Email
                </a>
            </div>
          </div>
      </div>

      <div class="card col-md-12 offset-md-0" style="margin-top: 30px;">
        <div class="card-header">
        <h2>Sent Messages</h2>
        </div>
        <div style="margin-top: 20px;">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>To name</th>
                        <th>To email</th>
                        <th>From name</th>
                        <th>From email</th>
                        <th>Body</th>
                        <th>Delivered</th>
                        <th>Sent Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="message in messages" :key="message.id">
                        <td style="width: 15%">{{message.toName}}</td>
                        <td style="width: 15%">{{message.toEmail}}</td>
                        <td style="width: 15%">{{message.fromName}}</td>
                        <td style="width: 15%">{{message.fromEmail}}</td>
                        <td style="width: 30%">{{message.body}}</td>
                        <td style="width: 10%">{{message.delivered}}</td>
                        <td style="width: 10%">{{ message.send_date }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
      </div>


    <!-- The Modal -->
    <div class="modal fade" id="create_form_modal" tabindex="-1" role="dialog" 
        aria-labelledby="addNewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"  id="addNewLabel">Send Email</h5>
                <button type="button" class="close" data-dismiss="modal"
                aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form @submit.prevent="sendEmail">
                <div class="modal-body">
                    <div class="form-group">
                        <label>To name</label>
                        <input v-model="toName" type="text" name="toName" 
                          placeholder="To name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>To email</label>
                        <input v-model="toEmail" type="email" name="toEmail" 
                          placeholder="To Email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Message: </label>
                        <textarea v-model="body" name="body" id="body" 
                          placeholder="Body of message" class="form-control" rows="5">
                        </textarea>
                    </div>
                    <div class="form-group">
                        <label>From name</label>
                        <input v-model="fromName" type="text" name="fromName" 
                          placeholder="From name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>From email</label>
                        <input v-model="fromEmail" type="email" name="fromEmail" 
                          placeholder="From email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label style="margin-bottom: 10px;">When to Send:</label>
                        <div class="form-control">
                            <span style="margin-right: 20px;">
                                <input type="radio" name="sending" 
                                  value="now" 
                                  v-model="item" checked
                                >
                                <label>Send Now</label>
                            </span>
                            <span>
                                <input type="radio" name="sending" 
                                  value="later" 
                                  v-model="item"
                                 >
                                <label>Send Later</label>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-control" v-if="item === 'later'">
                    <VueCtkDateTimePicker :no-button-now = "true"	 
                      v-model="send_date" 
                      :min-date="minDate"
                     />
                   
                </div>

                <div class="modal-footer">
                    <button
                        :disabled="disabled" v-if="loading && item === 'now'"
                        type="submit" class="btn  btn-success">
                        Sending Email...
                    </button>
                    <button
                        :disabled="disabled" 
                        v-if="!loading && item === 'now'"
                        type="submit" class="btn  btn-success">
                        Send Email
                    </button>
                    <button  
                        v-if="!loading && item === 'later'"
                        :disabled="disabled"
                        type="submit" 
                        class="btn  btn-success"
                        >
                        Send Later
                    </button>
                </div>
            </form>
            </div>
        </div>
    </div>
    <!-- End Modal -->
  </div>
</template>

<script>
import axios from 'axios'
import moment from 'moment'

// var currentDate = new Date();
// console.log(currentDate);

// var currentDateWithFormat = new Date().toJSON().slice(0,16).replace(/-/g,'-');
// console.log(currentDateWithFormat);

export default {
  data(){
      return {
          messages: [],
          send_now: true,
          loading: false,
          toName: '',
          toEmail: '',
          fromName: '',
          fromEmail: '',
          body: '',
          send_date: '',
          item: 'now',
          minDate: moment().format('YYYY-MM-DD hh:mm a')
      }
  },
  created(){
      this.getMessages();
},
  computed: {
      disabled(){
      return    this.toName === '' || !this.toName ||
                this.toEmail === '' || !this.toEmail ||
                this.fromName === '' || !this.fromName ||
                this.fromEmail === '' || !this.fromEmail || 
                this.body === '' || !this.body || this.loading 
    },
  },
  methods: {
    getMessages(){
         axios.get('/get_messages').then(res => {
            this.messages = res.data;
        })
    },
    openModal(){
        $('#create_form_modal').modal('show');
    },
    
    sendEmail () {
      this.loading = true
      const sendData = { 
                toName: this.toName, 
                toEmail: this.toEmail, 
                fromName: this.fromName, 
                fromEmail: this.fromEmail, 
                body: this.body, 
                send_date: this.send_date, 
                item: this.item 
             }
    axios.post('/notifications', sendData)
        .then((resp) => {
          console.log(resp);
            $('#create_form_modal').modal('hide');
            if (this.item == 'now') {
                toast.fire(
                    'Sent!',
                    'Email Sent to Users',
                    'success'
                )
            } else {
                toast.fire(
                    'Scheduled!',
                    'Email Scheduled! To Be Sent Later',
                    'success'
                )
            }
          this.toName = '';
          this.toEmail = '';
          this.fromName = '';
          this.fromEmail = '';
          this.body = '';
          console.log(resp)
          this.loading = false 
          setTimeout(() => {
            window.location.reload(window.origin + '/');
          }, 2000)
        })
        .catch(error => console.log(error))
    },
  }
}

</script>

<style scoped>
.btn {
  margin-right: 10px;
  margin-bottom: 10px;
}
</style>