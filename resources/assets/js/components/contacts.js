module.exports = {
    props: ['item', 'url'],

    template: require("./contacts.html"),

    data: function () {
        return {
            customers: [],
            companies: [],
            salesTeams: [],
            titles: [],
            can_write: true,
            can_delete: true,
            errors: false
        }
    },

    methods: {
        loadContacts: function () {
            this.$http.get(this.url + 'data')
                .success(function (response) {
                    this.$set('customers', _.map(response.customers, function (item) {
                        item.selected = false;
                        return item;
                    }));
					
					console.log(response);
                    //this.$set('customers', response.customers);
                    this.$set('companies', response.companies);
                    this.$set('salesTeams', response.salesTeams);
                    this.$set('titles', response.titles);
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
            _.each(this.customers, function (item) {
                item.selected = status;
            });
        },

        deleteItem: function (item) {
            var confirm = window.confirm("Deleting customer " + item.full_name);
            if (confirm) {
                this.customers.$remove(item);
                this.item = this.customers[1];

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
                    this.item = response.data.user;
                    this.loadContacts();
                    this.errors = false;
                    this.$set('item.editing', false);
                })
                .error(function (error) {
                    this.errors = error;
                });
        },

        openImportModal: function () {
            $('#importModal').modal('show');
        },

        uploadFile: function () {

            var formData = new FormData();
            formData.append('file', this.$els.fileinput.files[0]);

            this.$http.post(this.url + 'import-excel-data', formData)
                .success(function (res) {
                    console.log(res);
                    //this.success = res.success;
                    this.errors = false;
                    this.loadContacts();
                    $('#importModal').modal('hide');
                }).error(function (err) {
                    console.log(err);
                    this.errors = err;
                })
        }
    },

    ready: function () {
        this.loadContacts();

        $('.scrollable').css('height', (window.innerHeight - 150));
    }
};