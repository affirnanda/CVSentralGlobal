describe('TC-BF-6V', () => {

  beforeEach(() => {
    cy.visit('http://127.0.0.1:8000/login')

    cy.get('#email').type('super@admin.com')
    cy.get('#password').type('admin123')

    cy.contains('button', 'Masuk').click()

    cy.url().should('include', '/dashboard')

    cy.visit('http://127.0.0.1:8000/admin/products')

    cy.contains('Edit').first().click()
  })

  it('Admin mengedit produk dengan nama produk kosong', () => {

    cy.get('input[name="name"]')
      .clear()
      

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

    cy.contains('Nama produk tidak boleh kosong')
      .should('exist')

  })

})