<template>
  <VContainer>
    <VLayout
      row
      wrap
      justify-center
    >
      <VFlex 
        md3
        xs12
        class="mx-1"
      >
        <ServiceCard />
      </VFlex>

      <VFlex 
        md3
        xs12
        class="mx-1"
      >
        <CustomerCard />
      </VFlex>

      <VFlex 
        md3
        xs12
        class="mx-1"
      >
        <TransactionCard />
      </VFlex>

      <VFlex
        md6
        class="ma-1"
      >
        <VCard>
          <VCardTitle>
            <template>
              <h4 class="mb-1">Penjualan Sparepart Terbanyak</h4>
              <div class="canvas">
                
              </div>
            </template>
          </VCardTitle>
        </VCard>
      </VFlex>

      <VFlex
        md3
        class="ma-1"
      >
        <VCard>
          <VCardText>
            <h4>Motor Terbanyak diservis</h4>
          </VCardText>
          <VList one-line>
            <VDivider />
            <VListTile 
              v-for="list in lists"
              :key="list.id"
            >
              <VListTileTitle> {{ list.id + '.' }} {{ list.name }} </VListTileTitle>
            </VListTile>
          </VList>
        </VCard>
      </VFlex>
    </VLayout>
  </VContainer>
</template>

<script>
  import ServiceCard from '../../components/Dashboard/ServiceCard'
  import CustomerCard from '../../components/Dashboard/CustomerCard'
  import TransactionCard from '../../components/Dashboard/TransactionCard'

  export default {
    name: 'DashboardIndex',
    components: {
      ServiceCard,
      CustomerCard,
      TransactionCard
    },
    
    data () {
      return {
        lists: [
          {
            id: 1,
            name: 'Honda Mio'
          },
          {
            id: 2,
            name: 'Honda Beat'
          },
          {
            id: 3,
            name: 'Yamaha Mio'
          }
        ]
      }
    }
  }
</script>

<style scoped>
  .canvas {
    background-color: #e8eaed;
    border-radius: 3px;
    width: 100%;
    height: 400px;
  }
</style>


