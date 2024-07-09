mssimpleremains.page.Home = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        baseParams: {
            url: mssimpleremains.config.connectorUrl,
            action: 'mgr/settings/get'
        },
        components: [{
            xtype: 'mssimpleremains-panel-home'

        }],
        buttons: this.getButtons(),
    });
    mssimpleremains.page.Home.superclass.constructor.call(this, config);
};
Ext.extend(mssimpleremains.page.Home, MODx.Component, {
    getButtons: function () {
        var buttons = [];

        buttons.push({
            text: '<i class="icon icon-upload"></i> ' + _('mssimpleremains_import_btn'),
            handler: this.import,
            scope: this,
            keys: [{
                key: MODx.config.keymap_save || 's',
                ctrl: true,
                fn: this.save
            }]
        });

        buttons.push({
            text: _('mssimpleremains_save_btn'),
            handler: this.save,
            cls: 'primary-button',
            scope: this,
            keys: [{
                key: MODx.config.keymap_save || 's',
                ctrl: true,
                fn: this.save
            }]
        });

        return buttons;
    },
    save: function () {
        var fp = Ext.getCmp('mssimpleremains-form-settings');
        var form = fp.getForm();

        if (fp && form) {
            var params = fp.getForm().getValues();
            params['action'] = 'mgr/settings/save';

            fp.el.mask(_('saving'));
            MODx.Ajax.request({
                url: mssimpleremains.config.connectorUrl,
                params: params,
                listeners: {
                    success: {
                        fn: function (r) {
                            fp.el.unmask();
                            MODx.msg.status({
                                title: _('mssimpleremains_saved'),
                                message: _('mssimpleremains_saved_desc'),
                                delay: 4
                            })
                        }, scope: this
                    },
                    failure: {
                        fn: function (r) {
                            Ext.each(r.data, function (error) {
                                form.findField(error.id).markInvalid(error.msg);
                            });
                            fp.el.unmask();
                        }, scope: this
                    },
                    scope: this
                }
            });
        }
    },
    import: function () {
        var topic = '/mssimpleremains/';
        var register = 'mgr';


        var console = MODx.load({
            xtype: 'modx-console'
            , register: register
            , topic: topic
            , show_filename: 0
            , listeners: {
                'shutdown': {
                    fn: function () {

                    }, scope: this
                }
            }
        });


        console.show(Ext.getBody());

        MODx.Ajax.request({
            url: mssimpleremains.config.connectorUrl
            , params: {
                action: 'mgr/remains/import'
                , register: register
                , topic: topic
            }
            , listeners: {
                'success': {
                    fn: function () {
                        console.fireEvent('complete');
                    }, scope: this
                }
            }
        });
    }
});
Ext.reg('mssimpleremains-page-home', mssimpleremains.page.Home);