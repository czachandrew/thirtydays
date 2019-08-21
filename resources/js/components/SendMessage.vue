<template> 
<div>
   <b-form-group id="toGroup" label-cols-sm="4" label-cols-lg="3" description="Who are you sending this message to?" label="User Email" label-for="message_to">
      <b-form-input id="message_to" v-model="message.to"></b-form-input>
   </b-form-group>
   <b-form-group id="messageGroup" label-cols-sm="4" label-cols-lg="3" description="Enter your message" label="Message" label-for="message_body">
      <b-form-textarea id="message_body" v-model="message.body" rows="3" max-rows="5"></b-form-textarea>
   </b-form-group>
   <b-form-group id="sendEmail" label-cols-sm="4" label-cols-log="3" description="Do you want to send an email notification?" label-for="send_email">
      <b-form-checkbox
      id="send_email"
      v-model="message.email"
      name="send_email"
      value="true"
      unchecked-value="false">
         Send email and in-app message
      </b-form-checkbox>
   </b-form-group>
   <button class="btn btn-sm btn-primary" @click="send">Send</button>
</div>
</template>
<style>

</style>
<script>
   export default {
      props: ['single', 'group'],
      data() {
         return {
            message: {
               to: '',
               body: '',
               email: false
            }
         }
      },
      methods: {

      },
      mounted () {

      }
   }

</script>
