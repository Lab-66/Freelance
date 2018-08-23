module.exports = {
    props: [],

    template: require("./mail-compose.html"),

    data: function () {
        return {
            users: null,
            emailTemplates: null,
            data: {
                recipients: null
            },
            have_email_template: true
        }
    },

    methods: {
        sendMail: function () {
            var data = this.data;
            if (data.recipients != null && data.subject != null && data.message != null) {
                this.$http.post(this.url + '/send', data).then(function (response) {
                    this.data = {}
                    toastr["success"]("Email sent successfully");
                }.bind(this));
            } else {
                //alert('Please fill all the required fields.');
                toastr["error"]("Please fill the required fields");
            }
        },

        loadData: function () {
            var self = this;
            this.$http.get(this.url + '/data', this.query).then(function (response) {
                this.$set('users', response.data.users);
                this.$set('emailTemplates', response.data.email_templates);
                this.$set('have_email_template', response.data.have_email_template);
                this.$set('loaded', true);

                this.$watch('data.emailTemplate', function (val) {
                    if (val) {
                        this.$http.get(this.url + '/mail-template/' + val).then(function (response) {
                            console.log(response);
                            self.$set('data.message', response.data.template.text)
                        }, function (error) {

                        });
                    }
                });
            }, function (error) {

            });
        }
    },

    ready: function () {
        this.url = this.$parent.url;
        this.loadData();
    },

    events: {},

    route: {
        activate: function () {
            
        }
    }
}