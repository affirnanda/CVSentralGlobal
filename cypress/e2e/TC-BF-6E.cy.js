describe('TC-BF-6E', () => {

  beforeEach(() => {

    cy.visit('http://127.0.0.1:8000/login')

    cy.get('#email').type('super@admin.com')
    cy.get('#password').type('admin123')

    cy.contains('button', 'Masuk').click()

    cy.url().should('include', '/dashboard')

    cy.visit('http://127.0.0.1:8000/admin/products/create')

  })

  it('Admin menambah produk dengan data lengkap', () => {

    cy.get('input[name="name"]').type('Produk Cypress')

    cy.get('textarea[name="description"]')
      .type('Produk testing otomatis')

    cy.get('input[name="price"]')
      .type('100000')

    cy.get('input[name="rental_price"]')
      .type('50000')

    cy.get('input[name="stock"]')
        .clear()
      .type('10')

    cy.get('button[type="submit"]')
      .contains('Save Product')
      .click()

    // Expected Result
    cy.contains('Produk berhasil')
  })

})