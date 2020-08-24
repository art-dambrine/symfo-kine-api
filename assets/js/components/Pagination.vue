<template>
    <div>
        <nav aria-label="Page navigation example">
            <ul class="pagination">

                <li :class="{'page-item': true, 'disabled': (currentPage === 1)}">
                    <button class="page-link" @click="onPageChange(currentPage - 1)" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </button>
                </li>

                <li v-for="page in pages" :key="page" :class="{'page-item': true, 'active': (page === currentPage)}">
                    <button
                            class="page-link" @click="onPageChange(page)">{{page}}
                    </button>
                </li>

                <li :class="{'page-item': true, 'disabled': (currentPage === pagesCount)}">
                    <button class="page-link" @click="onPageChange(currentPage + 1)" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </button>
                </li>

            </ul>
        </nav>
    </div>
</template>

<script>
  export default {
    name: 'Pagination',
    props: ['currentPage', 'itemsPerPage', 'tableLength', 'onPageChange'],
    computed: {
      pagesCount () {
        return Math.ceil(this.tableLength / this.itemsPerPage)
      },
      pages () {
        let pages = []
        for (let i = 1; i <= this.pagesCount; i++) {
          pages.push(i)
        }
        return pages
      }
    }

  }

  export const getDataPagination = {
    paginatedItems (items, currentPage, itemsPerPage) {
      let startItem = currentPage * itemsPerPage - itemsPerPage

      if (items != null)
        return items.slice(startItem, startItem + itemsPerPage)
      else
        return null
    }
  }
</script>

<style scoped>

</style>