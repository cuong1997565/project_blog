<template>
    <div class="row">
        <div class="col-12">
            <div class="btn-group pull-right m-t-15">
                <router-link to="/categories/create" class="btn btn-default waves-effect waves-light">Thêm mới danh mục</router-link>
            </div>
            <h4 class="page-title">
                Danh mục
            </h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link to="/">Bảng điều khiển</router-link></li>
                <li class="breadcrumb-item active">Danh mục</li>
            </ol>
            <p class="clearfix"></p>
            <div class="card">
                <div class="card-header">
                    <div class="form-group has-search">
                        <span class="fa fa-search form-control-feedback"></span>
                        <input v-model="filters.q" type="text" class="form-control" placeholder="Tìm kiếm..." @keydown="filter()">
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tên</th>
                                        <th>Slug</th>
                                        <th>Danh mục cha</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(category, idx) in allCategories" :key="category.id">
                                        <td>{{ ++idx }}</td>
                                        <td>{{ category.name }}</td>
                                        <td>{{ category.slug }}</td>
                                        <td>{{ category.parent_name }}</td>
                                        <td>
                                            <router-link class="btn btn-link btn-action text-muted" :to="{name: 'category.edit', params: {id: category.id}}"><i class="fas fa-pencil-alt"></i></router-link>
                                            <a class="btn btn-link btn-action text-danger" @click="deleteCategory(category.id)"><i class="fas fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer" v-if="categoryPagination.last_page > 1">
                    <nav class="pull-right">
                        <paginate
                        :page-count="categoryPagination.last_page"
                        :page-range="5"
                        :margin-pages="2"
                        :click-handler="paginationChange"
                        prev-text="«"
                        next-text="»"
                        container-class="pagination"
                        page-class="page-item"
                        page-link-class="page-link"
                        next-class="page-item"
                        next-link-class="page-link"
                        prev-class="page-item"
                        prev-link-class="page-link">
                      </paginate>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { mapActions, mapGetters } from 'vuex'
import { debounce } from 'lodash'
export default {
    data () {
        return {
            filters: {
                q: null,
                page: null
            }
        }
    },
    methods: {
        ...mapActions(['fetchCategories', 'removeCategory']),
        paginationChange (page) {
            this.filters.page = page
            this.filter()
        },

        filter: debounce(function () {
            this.fetchCategories({params: this.filters})
        }, 500),
        deleteCategory (id) {
            swal({
              title: 'Cảnh báo?',
              text: "Bạn chắc chắn muốn xóa bản ghi này?",
              type: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Xóa',
              cancelButtonText: 'Không',
              reverseButtons: true,
              confirmButtonClass: 'btn btn-success',
              cancelButtonClass: 'btn btn-danger mr-2',
              buttonsStyling: false,
            }).then((result) => {
              if (result) {
                this.removeCategory(id)
                this.filter()
              }
            })
        }
    },
    computed: {
        ...mapGetters(['allCategories', 'categoryPagination'])
    },
    mounted() {
        this.fetchCategories()
    }
}
</script>

<style scoped>
.has-search .form-control {
    padding-left: 2.375rem;
}

.has-search .form-control-feedback {
    position: absolute;
    z-index: 2;
    display: block;
    width: 2.375rem;
    height: 2.375rem;
    line-height: 2.375rem;
    text-align: center;
    pointer-events: none;
    color: #aaa;
}
</style>
