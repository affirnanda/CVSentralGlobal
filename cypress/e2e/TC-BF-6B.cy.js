describe('TC-BF-6B', () => {

    it('User memasukkan jumlah melebihi stok', () => {

        cy.visit('http://127.0.0.1:8000/katalog-produk')

        cy.get('form')
            .first()
            .within(() => {

                cy.get('input[name="qty"]')
                    .clear()
                    .type('15')

                cy.get('button[type="submit"]')
                    .click()
            })

        // sesuai test case
        cy.contains('Stok barang tidak mencukupi')
    })

})