describe('TC-BF-6K', () => {

  beforeEach(() => {

     cy.visit('http://127.0.0.1:8000/login')

    cy.get('#email').type('super@admin.com')
    cy.get('#password').type('admin123')
    cy.contains('button', 'Masuk').click()

    cy.url().should('include', '/dashboard')

    cy.visit('http://127.0.0.1:8000/admin/products/create')
  })

  it('Admin menambah produk dengan stok produk melebihi max integer', () => {

    cy.get('input[name="name"]').type('Produk Stok Besar')

    cy.get('textarea[name="description"]')
      .type('Deskripsi produk')

    cy.get('input[name="price"]')
      .type('10000')

    cy.get('input[name="rental_price"]')
      .type('5000')

    cy.get('input[name="stock"]')
      .clear()
      .type('2147483648')

    cy.get('input[type="file"]')
      .selectFile('cypress/fixtures/image.jpg', { force: true })

    cy.contains('button', 'Save Product').click()

    cy.contains('Jumlah stok melebihi batas')
      .should('exist')
  })

})