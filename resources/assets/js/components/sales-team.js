module.exports = {
    props: ['url'],

    data: function () {
        return {
            data: null,
            staff: null,
            selectedAll: false
        }
    },

    template: require("./sales-team.html"),


    filters: {
        success: function (items) {
            return items.filter(function (item) {
                return item.created;
            });
        },

        rejected: function (items) {
            return items.filter(function (item) {
                return item.errors
            });
        }
    },

    computed: {
        completed: function () {
            return this.data.filter(function (item) {
                return item.created;
            });
        },

        remaining: function () {
            return this.data.filter(function (item) {
                return !item.created;
            });
        },

        total: function () {
            return this.data.length;
        },

        selected: function () {
            return this.data.filter(function (item) {
                return item.selected;
            });
        }
    },

    methods: {
        init: function (res) {
            //Excel ROWS
            this.$set('data', _.map(res.data.salesteams, function (item) {
                item.created = false;
                item.errors = false;
                item.selected = false;
                return item;
            }));

            //Staff to be used for Dropdown
            this.$set('staff', res.data.staff);

            //Look for select all checkbox
            this.$watch('selectedAll', function (selected) {
                this.updateRowsSelection(selected);
            });

            this.selectedAll = false;
        },

        updateRowsSelection: function (status) {
            _.each(this.data, function (item) {
                item.selected = status;
            });
        },

        uploadFile: function () {

            var formData = new FormData();
            formData.append('file', this.$els.fileinput.files[0]);

            this.$http.post(this.url + 'import', formData)
                .success(function (res) {
                    this.init(res);
                }.bind(this)).error(function (err) {

                })
        },

        createRecord: function (item) {
            if (!item.created) {
                var vm = this;
                this.$http.post(this.url + 'ajax-store', item)
                    .success(function (response) {
                        item.created = true;
                        item.selected = false;
                        item.errors = null;
                    })
                    .error(function (error) {
                        console.log(error);
                        item.errors = error;
                    });
            }
        },

        createAll: function () {
            this.selected.forEach(function (item) {
                this.createRecord(item);
            }.bind(this));
        }
    }
}