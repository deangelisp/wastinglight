import { getStorage } from 'vc-cake'
import lineicons from './src/lineicons-13.07-48' // NA https://designmodo.com/linecons-free/
import entypo from './src/entypo-13.07-411' // NA http://www.entypo.com/
import monosocial from './src/monosocial-1.10-303' // v1.10 https://drinchev.github.io/monosocialiconsfont/
import typicons from './src/typicons-2.0.7' // v2.0.7, v2.0.9 available, but not needed https://www.s-ings.com/typicons/
import openiconic from './src/openiconic-1.1.1' // v1.1.1 https://useiconic.com/open
import material from './src/material-3.0.1' // v3.0.1 https://material.io/resources/icons/?style=baseline
import batch from './src/batch-1.3' // v1.3 http://adamwhitcroft.com/batch/
import mfglabs from './src/mfglabs' // NA https://mfglabs.github.io/mfglabs-iconset/
import metrize from './src/metrize-1.0' // v1.0 http://www.alessioatzeni.com/metrize-icons/
import dripicons from './src/dripicons-2.0' // v2.0 http://demo.amitjakhu.com/dripicons/
import feather from './src/feather-4.24.0' // v4.24.0 https://feathericons.com
import linearicons from './src/linearicons-1.0-170' // v1.0 https://linearicons.com/free
import jam from './src/jam-2.0' // v2.0 https://jam-icons.com
import evil from './src/evil-1.9' // v1.9.0 https://evil-icons.io
import zondicons from './src/zondicons' // NA http://www.zondicons.com/icons.html
import socialicons from './src/socialicons' // NA https://github.com/konsav/social-icons

const attributesStorage = getStorage('attributes')

attributesStorage.trigger('iconpicker:add', 'icons', 'lineicons', lineicons)
attributesStorage.trigger('iconpicker:add', 'icons', 'entypo', entypo)
attributesStorage.trigger('iconpicker:add', 'icons', 'monosocial', monosocial)
attributesStorage.trigger('iconpicker:add', 'icons', 'typicons', typicons)
attributesStorage.trigger('iconpicker:add', 'icons', 'openiconic', openiconic)
attributesStorage.trigger('iconpicker:add', 'icons', 'material', material)
attributesStorage.trigger('iconpicker:add', 'icons', 'batch', batch)
attributesStorage.trigger('iconpicker:add', 'icons', 'mfglabs', mfglabs)
attributesStorage.trigger('iconpicker:add', 'icons', 'metrize', metrize)
attributesStorage.trigger('iconpicker:add', 'icons', 'dripicons', dripicons)
attributesStorage.trigger('iconpicker:add', 'icons', 'feather', feather)
attributesStorage.trigger('iconpicker:add', 'icons', 'linearicons', linearicons)
attributesStorage.trigger('iconpicker:add', 'icons', 'jam', jam)
attributesStorage.trigger('iconpicker:add', 'icons', 'evil', evil)
attributesStorage.trigger('iconpicker:add', 'icons', 'zondicons', zondicons)
attributesStorage.trigger('iconpicker:add', 'icons', 'socialicons', socialicons)
