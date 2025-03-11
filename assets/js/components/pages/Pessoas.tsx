import { Box, Flex } from '@chakra-ui/react'
import { TablePessoas } from '@components/pages/TablePessoas';

export default function Pessoas(){
    return(
        <Flex
        direction="column"
        align="center"
        justify="center"
        h="100vh"
        bgGradient="linear(to-r, #1d3c6d, #3b5f84, #2c4f69)"
        color="white"
        p={8}
        position="relative">
            <Box>
                <TablePessoas/>
            </Box>

        </Flex>
    );
}