import middleware, { auth } from '../middleware'

import LoginView from '../views/Login/LoginView'
import DashboardIndex from '../views/Dashboard/DashboardIndex'

import Branch from '../views/Branch/Branch'
import BranchCreate from '../views/Branch/BranchCreate'
import BranchEdit from '../views/Branch/BranchEdit'

import Employee from '../views/Employee/Employee'

export const routes = [
    {
        path: '/admin/login',
        name: 'login',
        component: LoginView,  
    },
    {
        path: '/admin',
        name: 'dashboard',
        component: DashboardIndex,
        meta: { role: [
            'Administrator',
            'Customer Service',
            'Cashier',
        ]},
        beforeEnter: middleware([
            auth
        ]) 
    },  
    {
        path: '/admin/branches',
        name: 'branches',
        component: Branch,
        meta: { role: ['Administrator'] },
        beforeEnter: middleware([
          auth
        ])
    },
    {
        name: 'branches.create',
        path: '/admin/branches/create',
        component: BranchCreate,
        meta: { role: ['Administrator'] },
        beforeEnter: middleware([
          auth
        ])
    },
    {
        name: 'branches.edit',
        path: '/admin/branches/edit',
        component: BranchEdit,
        meta: { role: ['Administrator'] },
        beforeEnter: middleware([
          auth
        ])
    },     
    {
        path: '/admin/employees',
        name: 'employees',
        component: Employee,
        meta: { role: ['Administrator'] },
        beforeEnter: middleware([
          auth
        ])
    },
]
