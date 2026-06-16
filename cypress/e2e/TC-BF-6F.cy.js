describe('TC-BF-6F', () => {

  beforeEach(() => {
      cy.visit('http://127.0.0.1:8000/login')

    cy.get('#email').type('super@admin.com')
    cy.get('#password').type('admin123')

    cy.contains('button', 'Masuk').click()

    cy.url().should('include', '/dashboard')

    cy.visit('http://127.0.0.1:8000/admin/products/create')
  })

  it('Admin upload gambar invalid', () => {

    cy.get('input[name="name"]').type('Produk Test')
    cy.get('textarea[name="description"]').type('Deskripsi')

    cy.get('input[name="price"]').type('10000')
    cy.get('input[name="rental_price"]').type('5000')
    cy.get('input[name="stock"]')
    .clear()
    .type('10')

    cy.get('input[type="file"]')
      .selectFile('cypress/fixtures/file.pdf')

    cy.contains('Save Product').click()

    cy.contains('Format gambar yang diunggah tidak sesuai')
  })
})