export { default as Logo } from '../../components/Logo.vue'
export { default as VuetifyLogo } from '../../components/VuetifyLogo.vue'
export { default as Loading } from '../../components/loading.vue'
export { default as CategoryDelete } from '../../components/category/CategoryDelete.vue'
export { default as CategoryForm } from '../../components/category/CategoryForm.vue'
export { default as CategoryList } from '../../components/category/CategoryList.vue'
export { default as ProductDelete } from '../../components/product/ProductDelete.vue'
export { default as ProductForm } from '../../components/product/ProductForm.vue'
export { default as ProductList } from '../../components/product/ProductList.vue'

export const LazyLogo = import('../../components/Logo.vue' /* webpackChunkName: "components/Logo" */).then(c => c.default || c)
export const LazyVuetifyLogo = import('../../components/VuetifyLogo.vue' /* webpackChunkName: "components/VuetifyLogo" */).then(c => c.default || c)
export const LazyLoading = import('../../components/loading.vue' /* webpackChunkName: "components/loading" */).then(c => c.default || c)
export const LazyCategoryDelete = import('../../components/category/CategoryDelete.vue' /* webpackChunkName: "components/category/CategoryDelete" */).then(c => c.default || c)
export const LazyCategoryForm = import('../../components/category/CategoryForm.vue' /* webpackChunkName: "components/category/CategoryForm" */).then(c => c.default || c)
export const LazyCategoryList = import('../../components/category/CategoryList.vue' /* webpackChunkName: "components/category/CategoryList" */).then(c => c.default || c)
export const LazyProductDelete = import('../../components/product/ProductDelete.vue' /* webpackChunkName: "components/product/ProductDelete" */).then(c => c.default || c)
export const LazyProductForm = import('../../components/product/ProductForm.vue' /* webpackChunkName: "components/product/ProductForm" */).then(c => c.default || c)
export const LazyProductList = import('../../components/product/ProductList.vue' /* webpackChunkName: "components/product/ProductList" */).then(c => c.default || c)
