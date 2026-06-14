describe('TC-BF-6Q', () => {

  beforeEach(() => {
    cy.visit('http://127.0.0.1:8000/login')

    cy.get('#email').type('super@admin.com')
    cy.get('#password').type('admin123')

    cy.contains('button', 'Masuk').click()

    cy.url().should('include', '/dashboard')

    cy.visit('http://127.0.0.1:8000/admin/products')
  })

  it('Admin mengedit produk dengan data yang benar', () => {

    cy.contains('Edit').first().click()

    cy.get('input[name="name"]')
      .clear()
      .type('Produk A')

    cy.get('textarea[name="description"]')
      .clear()
      .type('Deskripsi produk update')

    cy.get('input[name="price"]')
      .clear()
      .type('20000')

    cy.get('input[name="rental_price"]')
      .clear()
      .type('10000')

    cy.get('input[name="stock"]')
      .clear()
      .type('50')

    cy.get('input[type="file"]').selectFile(
      'cypress/fixtures/image.jpg',
      { force: true }
    )

    cy.contains('button', 'Update Product').click()

    cy.contains('Produk A')
      .should('exist')
  })

})