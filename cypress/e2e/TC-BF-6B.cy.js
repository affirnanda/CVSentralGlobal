describe('TC-BF-6B', () => {

  beforeEach(() => {
    cy.visit('http://127.0.0.1:8000/katalog-produk')
  })

  it('User memasukkan jumlah melebihi stok, produk tidak masuk ke keranjang', () => {

    // cek jumlah item di cart badge sebelum submit
    cy.get('#cartButton .absolute')
      .invoke('text')
      .then((before) => {

        cy.contains('Stok tersisa: 10')
          .parents('[data-aos]')
          .within(() => {
            cy.get('input[name="qty"]')
              .invoke('removeAttr', 'max') 
              .clear()
              .type('15')

            cy.get('form').submit()
          })

        cy.get('#cartButton .absolute')
          .invoke('text')
          .should('eq', before)
      })

  })

})