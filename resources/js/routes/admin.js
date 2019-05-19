import middleware, { auth } from '../middleware'

import LoginView from '../views/Login/LoginView'
import DashboardIndex from '../views/Dashboard/DashboardIndex'

import Branch from '../views/Branch/Branch'
import BranchCreate from '../views/Branch/BranchCreate'
import BranchEdit from '../views/Branch/BranchEdit'

import Employee from '../views/Employee/Employee'

import Supplier from '../views/Supplier/Supplier'

import Sales from '../views/Sales/Sales'

import User from '../views/User/User'

import Service from '../views/Service/Service'

import Sparepart from '../views/Sparepart/Sparepart'

import MotorcycleBrand from '../views/MotorcycleBrand/MotorcycleBrand'

import MotorcycleType from '../views/MotorcycleType/MotorcycleType'

import Customer from '../views/Customer/Customer'

import Procurement from '../views/Procurement/Procurement'

import Transaction from '../views/Transaction/Transaction'
import TransactionCreate from '../views/Transaction/AddTransaction'
import TransactionEdit from '../views/Transaction/EditTransaction'

import TransactionperYear from '../views/Report/TransactionperYear'
import BestSellerSparepart from '../views/Report/BestSellerSparepart'
import ServiceSelling from '../views/Report/ServiceSelling'
import RemainingStock from '../views/Report/RemainingStock'
import TransactionbyBranch from '../views/Report/TransactionbyBranch'
import ExpenseperYear from '../views/Report/ExpenseperYear'

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
    {
        path: '/admin/suppliers',
        name: 'suppliers',
        component: Supplier,
        meta: { role: ['Administrator'] },
        beforeEnter: middleware([
          auth
        ])
    },
    {
        path: '/admin/sales',
        name: 'sales',
        component: Sales,
        meta: { role: ['Administrator'] },
        beforeEnter: middleware([
          auth
        ])
    },
    {
        path: '/admin/users',
        name: 'users',
        component: User,
        meta: { role: ['Administrator'] },
        beforeEnter: middleware([
          auth
        ])
    },
    {
        path: '/admin/services',
        name: 'services',
        component: Service,
        meta: { role: ['Administrator'] },
        beforeEnter: middleware([
          auth
        ])
    },
    {
      path: '/admin/spareparts',
      name: 'spareparts',
      component: Sparepart,
      meta: { role: ['Administrator'] },
      beforeEnter: middleware([
        auth
      ])
    },
    {
      path: '/admin/motorcycleBrands',
      name: 'motorcycleBrands',
      component: MotorcycleBrand,
      meta: { role: ['Administrator'] },
      beforeEnter: middleware([
        auth
      ])
    },
    {
      path: '/admin/motorcycleTypes',
      name: 'motorcycleTypes',
      component: MotorcycleType,
      meta: { role: ['Administrator'] },
      beforeEnter: middleware([
        auth
      ])
    },
    {
      path: '/admin/customers',
      name: 'customers',
      component: Customer,
      meta: { role: ['Administrator'] },
      beforeEnter: middleware([
        auth
      ])
    },
    {
      path: '/admin/procurements',
      name: 'procurements',
      component: Procurement,
      meta: { role: ['Administrator'] },
      beforeEnter: middleware([
        auth
      ])
    },
    {
      path: '/admin/transactions',
      name: 'transactions',
      component: Transaction,
      meta: { role: ['Administrator','Cashier'] },
      beforeEnter: middleware([
        auth
      ])
    },
    {
      path: '/admin/transactions/create',
      name: 'transactions.create',
      component: TransactionCreate,
      meta: { role: ['Administrator'] },
      beforeEnter: middleware([
        auth
      ])
    },
    {
      path: '/admin/transactions/edit',
      name: 'transactions.edit',
      component: TransactionEdit,
      meta: { role: ['Administrator'] },
      beforeEnter: middleware([
        auth
      ])
    },
    {
      path: '/admin/transaction-per-year',
      name: 'transactionperYear',
      component: TransactionperYear,
      meta: { role: ['Administrator'] },
      beforeEnter: middleware([
        auth
      ])
    },
    {
      path: '/admin/best-seller-sparepart',
      name: 'sparepartBestSeller',
      component: BestSellerSparepart,
      meta: { role: ['Administrator'] },
      beforeEnter: middleware([
        auth
      ])
    },
    {
      path: '/admin/service-selling',
      name: 'serviceSelling',
      component: ServiceSelling,
      meta: { role: ['Administrator'] },
      beforeEnter: middleware([
        auth
      ])
    },
    {
      path: '/admin/remaining-stock',
      name: 'remainingStock',
      component: RemainingStock,
      meta: { role: ['Administrator'] },
      beforeEnter: middleware([
        auth
      ])
    },
    {
      path: '/admin/transaction-by-branch',
      name: 'transactionByBranch',
      component: TransactionbyBranch,
      meta: { role: ['Administrator'] },
      beforeEnter: middleware([
        auth
      ])
    },
    {
      path: '/admin/expense-per-year',
      name: 'expenseperYear',
      component: ExpenseperYear,
      meta: { role: ['Administrator'] },
      beforeEnter: middleware([
        auth
      ])
    },
]
