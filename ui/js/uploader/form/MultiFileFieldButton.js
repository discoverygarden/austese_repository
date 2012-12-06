/* Some code borrowed from https://github.com/ivan-novakov/extjs-upload-widget */
Ext.define('austese_repository.form.MultiFileFieldButton', {
    extend: 'Ext.form.field.File',
    buttonOnly: true,
    alias: 'widget.multifilefieldbutton',

    initComponent : function() {
        this.addEvents({
            'fileselected' : true
        });
        Ext.apply(this, {
            buttonConfig : {
                iconCls : this.iconCls,
                style: 'border:none', // disable separate border
                text : '' // disable text
            }
        });

        this.on('afterrender', function() {
            this.fileInputEl.dom.setAttribute('multiple', '1');
            this.fileInputEl.dom.setAttribute('name','data');
        }, this);

        this.on('change', function(field, value, options) {
            var files = this.fileInputEl.dom.files;
            if (files) {
                this.fireEvent('fileselected', this, files);
            }
        }, this);

        this.callParent(arguments);
    },

});