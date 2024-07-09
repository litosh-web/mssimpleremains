mssimpleremains.panel.Home = function (config) {

    var data = mssimpleremains.data;

    config = config || {};
    Ext.apply(config, {
        border: false,
        baseCls: 'modx-formpanel',
        cls: 'container',
        layout: 'anchor',
        items: [{
            html: '<h2>' + _('mssimpleremains') + '</h2>',
            border: false,
            cls: 'modx-page-header'
        }, {
            xtype: 'modx-tabs',
            defaults: {border: false, autoHeight: true},
            border: true,
            stateful: true,
            stateId: 'mssimpleremains-panel-home',
            stateEvents: ['tabchange'],
            getState: function () {
                return {activeTab: this.items.indexOf(this.getActiveTab())};
            },
            hideMode: 'offsets',
            items: [{
                title: _('mssimpleremains_settings'),
                layout: 'anchor',
                items: [{
                    html: _('mssimpleremains_warn_desc'),
                    border: false,
                    bodyCssClass: 'panel-desc'
                }, {
                    layout: 'form',
                    xtype: 'form',
                    id: 'mssimpleremains-form-settings',
                    labelAlign: 'top',
                    cls: 'main-wrapper',
                    items: [{
                        xtype: 'hidden',
                        name: 'id',
                        value: data.id
                    }, {
                        name: 'file',
                        fieldLabel: _('mssimpleremains_file'),
                        xtype: 'modx-combo-browser',
                        value: data.file
                    }, {
                        hiddenName: 'skip_first',
                        fieldLabel: _('mssimpleremains_skip_first'),
                        xtype: 'modx-combo-boolean',
                        value: data.skip_first,
                    }, {
                        hiddenName: 'ident',
                        fieldLabel: _('mssimpleremains_ident'),
                        xtype: 'modx-combo',
                        mode: 'local',
                        store: new Ext.data.ArrayStore({
                            fields: ['id', 'name'],
                            data: [
                                ["article", _('mssimpleremains_combo_article')],
                                ["id", _('mssimpleremains_combo_id')],
                                ["tv", _('mssimpleremains_combo_tv')],
                            ],
                        }),
                        listeners: {
                            select: this.initType,
                            afterrender: this.initType,
                        },
                        value: data.ident
                    }, {
                        id: 'tv_block',
                        hidden: true,
                        layout: 'form',
                        items: [{
                            fieldLabel: _('mssimpleremains_ident_tv'),
                            xtype: 'textfield',
                            name: 'ident_tv',
                            value: data.ident_tv
                        }]
                    }, {
                        name: 'tv_name',
                        fieldLabel: _('mssimpleremains_tv_name'),
                        xtype: 'textfield',
                        value: data.tv_name
                    }],

                }]
            }]
        }
        ]
    });
    mssimpleremains.panel.Home.superclass.constructor.call(this, config);
};
Ext.extend(mssimpleremains.panel.Home, MODx.Panel, {
    initType: function (c) {
        var v = c.getValue();
        var b = Ext.getCmp('tv_block');

        switch (v) {
            default:
                b.setVisible(false);
                break;
            case 'tv':
                b.setVisible(true);
                break;
        }
    }
});
Ext.reg('mssimpleremains-panel-home', mssimpleremains.panel.Home);