describe('TC-BF-8M', () => {

    it('Tidak bisa checkout', () => {

        cy.visit('/checkout/buy');

        cy.contains('Keranjang kosong');

    });

});