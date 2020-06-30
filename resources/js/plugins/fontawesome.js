import Vue from 'vue'
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

// import { } from '@fortawesome/free-regular-svg-icons'

import {
    faUser,
    faLock,
    faSignOutAlt,
    faCog,
    faPencilAlt,
    faTrash
} from '@fortawesome/free-solid-svg-icons'

import {
    faGithub,
    faFacebook,
    faTwitter
} from '@fortawesome/free-brands-svg-icons'

library.add(
    faUser,
    faLock,
    faSignOutAlt,
    faCog,
    faGithub,
    faFacebook,
    faTwitter,
    faPencilAlt,
    faTrash
)

Vue.component('fa', FontAwesomeIcon)