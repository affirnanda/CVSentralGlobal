describe('TC-BF-6C', () => {

  it('User memasukkan jumlah 0', () => {

    cy.visit('http://127.0.0.1:8000/katalog-produk')

    cy.get('input[name="qty"]')
      .first()
      .clear()
      .type('0')

    cy.get('input[name="qty"]')
      .first()
      .then(($input) => {
        expect($input[0].checkValidity()).to.equal(false)
      })

  })

})