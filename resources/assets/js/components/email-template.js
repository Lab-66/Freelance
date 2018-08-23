module.exports = {
    props: ['item', 'url'],

    template: require("./email-template.html"),

    data: function () {
        return {
            email_templates: [],
            can_write: true,
            can_delete: true,
            errors: false
        }
    },

    methods: {
        loadEmalTemplates: function () {
            this.$http.get(this.url + 'data')
                .success(function (response) {
                    this.$set('email_templates', _.map(response.email_templates, function (item) {
                        item.selected = false;
                        return item;
                    }));
                    this.$set('can_write', response.can_write);
                    this.$set('can_delete', response.can_delete);

                    if (!this.item) {
                        this.$set('item', response[0]);
                    }
                })
                .error(function (error) {
                    //alert('erro');
                });
        },

        updateSelection: function (status) {
            _.each(this.email_templates, function (item) {
                item.selected = status;
            });
        },

        deleteItem: function (item) {
            var confirm = window.confirm("Deleting email template " + item.title);
            if (confirm) {
                this.email_templates.$remove(item);
                this.item = this.email_templates[1];

                this.$http.delete(this.url + item.id)
                    .success(function (response) {

                    })
                    .error(function (error) {

                    });
            }


        },

        selectItem: function (item) {
            this.errors = false;

            this.updateSelection(false);
            item.selected = true;
            this.$set('item', item);
        },

        editItem: function (item) {
            this.$set('item.editing', true);
            item.editing = true;
        },

        doneEditing: function (item) {
            this.$http.put(this.url + item.id + '/ajax', item)
                .success(function (response) {
                    this.item = response.data.emailTemplate;
                    this.loadEmalTemplates();
                    this.errors = false;
                    this.$set('item.editing', false);
                })
                .error(function (error) {
                    this.errors = error;
                });
        },
    },

    ready: function () {
        this.loadEmalTemplates();

        $('.scrollable').css('height', (window.innerHeight - 150));
    }
};