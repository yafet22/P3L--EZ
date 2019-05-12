import HomeView from '../views/Home/HomeView'
import MotorCheck from '../views/Home/MotorCheck'
import SparepartView from '../views/Home/SparepartView'

export const routes = [
    {
        path: '/',
        name: 'home',
        component: HomeView,  
    },
    {
        path: '/motorcycle',
        name: 'customer.motor',
        component: MotorCheck,  
    },
    {
        path: '/sparepart',
        name: 'customer.sparepart',
        component: SparepartView,  
    }
]