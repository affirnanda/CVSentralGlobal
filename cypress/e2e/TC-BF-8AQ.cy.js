describe('TC-BF-8AQ', () => {

    beforeEach(() => {
        cy.visit('/testing/isi-cart');
    });

    it('TC-BF-8AQ Tanggal mulai kosong', () => { 
        cy.isiCheckoutRentValid(); 
        cy.get('input[name="rent_start"]').clear(); 
        cy.get('button[type="submit"]').click(); 
        cy.contains('Silahkan pilih tanggal mulai sewa anda'); 
    });

});