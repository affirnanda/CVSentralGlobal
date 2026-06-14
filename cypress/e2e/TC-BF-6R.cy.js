describe('TC-BF-6R', () => {

  beforeEach(() => {
    cy.visit('http://127.0.0.1:8000/login')

    cy.get('#email').type('super@admin.com')
    cy.get('#password').type('admin123')

    cy.contains('button', 'Masuk').click()

    cy.url().should('include', '/dashboard')

    cy.visit('http://127.0.0.1:8000/admin/products')

    cy.contains('Edit').first().click()
  })

  it('Admin mengedit produk dengan format gambar salah', () => {

    cy.get('input[type="file"]').selectFile(
      'cypress/fixtures/tenor.gif',
      { force: true }
    )

    cy.contains('button', 'Update Product').click()

    cy.contains('Format gambar yang diunggah tidak sesuai')
      .should('exist')

  })

})