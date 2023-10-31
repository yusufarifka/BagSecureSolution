
import '../css/quasar.sass'
import '@quasar/extras/roboto-font/roboto-font.css'
import '@quasar/extras/material-icons/material-icons.css'
import '@quasar/extras/material-icons-outlined/material-icons-outlined.css'
import '@quasar/extras/fontawesome-v5/fontawesome-v5.css'
import '@quasar/extras/themify/themify.css'
import '@quasar/extras/ionicons-v4/ionicons-v4.css'
import '@quasar/extras/mdi-v4/mdi-v4.css'
import 'animate.css'
import MaterialIconSet from 'quasar/icon-set/fontawesome-v5'
MaterialIconSet.table.arrowUp = 'fas fa-sort-amount-down-alt'

import { Loading,Notify } from 'quasar'

// To be used on app.use(Quasar, { ... })
export default {
  config: {
    loading: { /* look at QuasarConfOptions from the API card */ },
    notify: { /* look at QuasarConfOptions from the API card */ }
  },
  plugins: {
    Loading,
    Notify
  },
  animations: 'all'

}
