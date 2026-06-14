describe('TC-BF-6T', () => {

  beforeEach(() => {
    cy.visit('http://127.0.0.1:8000/login')

    cy.get('#email').type('super@admin.com')
    cy.get('#password').type('admin123')

    cy.contains('button', 'Masuk').click()

    cy.url().should('include', '/dashboard')

    cy.visit('http://127.0.0.1:8000/admin/products')

    cy.contains('Edit').first().click()
  })

  it('Admin mengedit produk dengan nama produk (≤100 karakter)', () => {

    cy.get('input[name="name"]')
      .clear()
      .type('satu karakter')

    cy.get('textarea[name="description"]')
      .clear()
      .type('Deskripsi update')

    cy.get('input[name="price"]')
      .clear()
      .type('25000')

    cy.get('input[name="rental_price"]')
      .clear()
      .type('10000')

    cy.get('input[name="stock"]')
      .clear()
      .type('20')

    

    cy.contains('button', 'Update Product').click()

    cy.contains('100')
      .should('exist')

  })

})