describe('TC-BF-6A', () => {

    it('User memasukkan produk ke keranjang', () => {

        cy.visit('http://127.0.0.1:8000/katalog-produk')

        // ambil produk pertama yang stoknya tersedia
        cy.get('form')
            .first()
            .within(() => {

                cy.get('input[name="qty"]')
                    .clear()
                    .type('2')

                cy.get('button[type="submit"]')
                    .click()
            })

        // tetap berada di halaman katalog
        cy.url().should('include', '/katalog-produk')

        // badge cart berubah menjadi 2
        cy.get('#cartButton')
            .should('contain', '2')
    })

})