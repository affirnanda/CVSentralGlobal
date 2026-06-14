describe('TC-BF-6J', () => {

  beforeEach(() => {

     cy.visit('http://127.0.0.1:8000/login')

    cy.get('#email').type('super@admin.com')
    cy.get('#password').type('admin123')
    cy.contains('button', 'Masuk').click()

    cy.url().should('include', '/dashboard')

    cy.visit('http://127.0.0.1:8000/admin/products/create')
  })

  it('Admin menambah produk dengan nama produk kosong', () => {

    // nama dikosongkan

    cy.get('textarea[name="description"]')
      .type('Deskripsi produk')

    cy.get('input[name="price"]')
      .type('10000')

    cy.get('input[name="rental_price"]')
      .type('5000')

    cy.get('input[name="stock"]')
      .clear()
      .type('10')

    cy.get('input[type="file"]')
      .selectFile('cypress/fixtures/image.jpg', { force: true })

    cy.contains('button', 'Save Product').click()

    cy.contains('Nama produk tidak boleh kosong')
      .should('exist')
  })

})